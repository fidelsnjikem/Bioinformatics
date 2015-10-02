

## program that runs directly BLAST from a python Terminal

## program description : It takes a query sequence from a patient and compares it to every known bacteria or virus that has every been sequenced.

##NB : server is blast server that is run by NCBI. we  use python to run the program on thier server via  the internet

#use BioPython module called Blast and import a set of methods from NCBI
from Bio.Blast import NCBIWWW

# read files containing the query sequence you want to run a blast against
fasta_string = open("/Users/fidelis/Desktop/test/sequence.fa").read()

#NCBIWWW.qblast method to run blast , takes as parameters blastn(type of blast); blastn searches nucleotides against nucleotides, fasta_string(sequence to find match, nt( database to search); nt is a non redundant database of everything stored in ncbi
result_handle = NCBIWWW.qblast("blastn","nt", fasta_string)

## Handle the returned Blast Record -------------------------------------------------------------------------

from Bio.Blast import NCBIXML      ## imports modules to read blast output

blast_record = NCBIXML.read(result_handle)  ## converts or parses blast output to readabe XML

#threshold value, for probablity of random occurence . the smaller the better
E_VALUE_THRESH = 0.01

for alignment in blast_record.alignments: # for all alignments in blast record (main loop)
    for hsp in alignment.hsps:      # for all high score pairs  in the alignment within the blast record(sub loop)
                #loop through the high score pairs and get/print  all reads below the  e-value threshold
                if hsp.expect < E_VALUE_THRESH:           #if below threshold
                        print('****Alignment****')
                        print('sequence:', alignment.title)   #print title
                        print('length:', alignment.length)    #print read length
                        print('e value:', hsp.expect)         #print e value (ie: should be low and less than0.01)
                        print(hsp.query)                      #print query sequence
                        print(hsp.match)                      #print match sequence
                        print(hsp.sbjct)                      
